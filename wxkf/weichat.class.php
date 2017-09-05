<?php 
	class weiChat{
		public $appid;
		public $appsecret;
		public function __construct($appid,$appsecret){
			$this->appid = $appid;
			$this->appsecret = $appsecret;
		}
		/*
			token 微信服务器跟自己的服务器进行通讯验证
			access token 验证微信后台接收的信息是否来自 微信公众号服务器的通讯
		*/
		//验证消息的真实性
		public function volid(){
			//GET接收随机字符串
			$echostr = $_GET['echostr'];
			if($this -> checkSignature()){
				echo $echostr;
			}else{
				echo "error";
				exit();
			}
		}
		/*
		 * 	接收GET传过来的参数
		 *	判断信息的真实性
		*/
		public function checkSignature(){
			//GET接收微信加密签名
			$signature = $_GET['signature'];
			//GET接收时间戳
			$timestamp = $_GET['timestamp'];
			//GET接收随机数
			$nonce = $_GET['nonce'];
			$tmpArr = array(TOKEN, $timestamp, $nonce);
		  	sort($tmpArr, SORT_STRING);
		  	$tmpStr = implode( $tmpArr );
		  	$tmpStr = sha1( $tmpStr );
		  	if($tmpStr == $signature){
		  		return true;
		  	}else{
		  		return false;
		  	}
		}
	  	/*
		 * 	将xml数据转化为对象
		 *	自动回复功能
	  	 *	从postObj对象中取元素
	  	*/
		public function responseMsg(){
			//接收原生的xml字符串
		  	$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		  	if(!$postStr){
		  		echo "post data error";
		  		exit;
		  	}
		  	//将xml数据转化为对象
		  	$postObj = simplexml_load_string($postStr,'SimpleXMLElement',LIBXML_NOCDATA);
		  	//接收消息的类型
		  	$MsgType = $postObj -> MsgType;
			//处理消息的类型  	
		  	$this -> checkMsgType($postObj,$MsgType);
		}
		//处理消息的类型
		public function checkMsgType($postObj,$MsgType){
			switch ($MsgType) {
	  			//处理文本消息的方法
		  		case 'text':
  					$this -> recevieText($postObj);
		  			break;
	  			//处理图片的方法
		  		case 'image':
					$this -> replyImage($postObj);
						break;
	  			//处理语音方法
				case 'voice':
					$this -> replyVoice($postObj);
					break;
	  			//处理关注事件
				case 'event':
					$Event = $postObj->Event;
					//处理事件的方法
					$this -> checkEvent($postObj,$Event);
					break;
		  		default:
		  			break;
		  	}
		}
		/*
			获取access_token
		*/
		public function get_access_token(){
				$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appid}&secret={$this->appsecret}";
				$request = $this->https_request($url);
				return $request['access_token'];
		}

		/*
			模拟post,get请求
		*/
		public function https_request($url,$data=""){
				//开启curl
				$ch = curl_init();
				//设置传输选项
				//设置传输地址
				curl_setopt($ch,CURLOPT_URL,$url);
				//以文件流的形式返回
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
				if($data){
					//以POST方式
					curl_setopt($ch,CURLOPT_POST,1);
					curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
				}
				//发送curl
				$request = curl_exec($ch);
				$tmpArr = json_decode($request,TRUE);
				if(is_array($tmpArr)){
					return $tmpArr;
				}else{
					return $request;
				}
				//关闭资源
				curl_close($ch);
		}

		/*
		 	$Event 微信服务器发过来的时间参数
			subscribe 关注事件
			unsubscribe 取消关注事件
			接收关注取消时间的推送
		*/
		/*
			创建菜单
		*/
		public function mune_create($data){
			$access_tokens = $this->get_access_token();
			$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$access_tokens}";
			return $request = $this->https_request($url,$data);
		}
		/*
			查询菜单
		*/
		public function mune_select(){
			$access_tokens = $this->get_access_token();
			$url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token={$access_tokens}";
			return $request = $this->https_request($url);
		}
		/*
			删除菜单
		*/
		public function mune_delete(){
			$access_tokens = $this->get_access_token();
			$url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token={$access_tokens}";
			return $request = $this->https_request($url);
		}
		/*
		 *	事件处理
		*/
		public function checkEvent($postObj,$Event){
			switch ($Event) {
				//关注事件
				case 'subscribe':
						$data = array(
								array(
									'Title' =>'欢迎来到周冬公众平台一起分享喜悦',
									'Description'=>'痛苦的呼唤',
									'PicUrl' => 'http://www.afefgrw.top/wxkf/image/a.png',
									'Url' => 'http://www.baidu.com',
								),
								array(
									'Title' =>'三千一百万的故事',
									'Description'=>'痛苦的呼唤',
									'PicUrl' => 'http://www.afefgrw.top/wxkf/image/b.png',
									'Url' => 'http://www.phphkhbd.com',
								),
								array(
									'Title' =>'三千二百万的故事',
									'Description'=>'痛苦的呼唤',
									'PicUrl' => 'http://www.afefgrw.top/wxkf/image/c.png',
									'Url' => 'http://www.baidu.com',
								),
							);
						$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->get_access_token()."&openid=".$postObj->FromUserName."&lang=zh_CN";
						$this -> replyText($postObj,$url);
					break;
				//取消关注事件
				case 'unsubscribe':
					break;
				//菜单点击事件
				case 'CLICK':
					$this -> checkClick($postObj,$postObj ->EventKey);
					break;
				//关注时获取用户地理位置信息
				case 'LOCATION':
					//1 在这里连接数据库将经纬度保存到数据库里面
					//2 在输入ss九点 进行搜索的时候 在checkMsgType方法中查询数据库  用url连接进行展示
					// $this -> replyText($postObj,'');
					break;
				default:
					break;
			}
		}
		//处理文本消息的方法
		public function recevieText($postObj){
			$content = $postObj ->Content;
  			switch ($content) {
  				case '点歌':
  					$str = "欢迎来到周冬私人点歌系统\n";
					$files = scandir('music');
					$i = 1;
					foreach ($files as $key => $v) {
						if($v != '.' && $v != '..'){
							$str .= $i .' '. $v ."\n";
							$i++;
						}
					}
					$str .="请输入对应的歌曲编号\n";
					$this -> replyText($postObj,$str);
					break;
				case 'zhangjiao':
					$this -> replyText($postObj,'I love you');
					break;
				case '新闻':
					$data = array(
								array(
									'Title' =>'三千万的故事',
									'Description'=>'痛苦的呼唤',
									'PicUrl' => 'http://www.afefgrw.top/wxkf/image/a.png',
									'Url' => 'http://www.afefgrw.top/wxkf/jssdk.php',
								),
								array(
									'Title' =>'三千一百万的故事',
									'Description'=>'痛苦的呼唤',
									'PicUrl' => 'http://www.afefgrw.top/wxkf/image/b.png',
									'Url' => 'http://www.afefgrw.top/wxkf/jssdk.php',
								),
								array(
									'Title' =>'三千二百万的故事',
									'Description'=>'痛苦的呼唤',
									'PicUrl' => 'http://www.afefgrw.top/wxkf/image/c.png',
									'Url' => 'http://www.baidu.com',
								),
							);
					$this -> replyNews($postObj,$data);
					break;
				default:
					//正则判断是不是数字	$content 输入的编码
					if(preg_match('/^\d{1,2}$/',$content)){
						//遍历目录下面的文件
						$files = scandir('music');
						$i = 1;
						foreach ($files as $key => $v) {
							if($v != '.' && $v != '..'){
								if($content == $i){
									$data = array(
										'Title' => $v,
										'Description' => $v,
										'MusicUrl' => 'http://www.afefgrw.top/wxkf/music/' .$v,
										'HQMusicUrl' => 'http://www.afefgrw.top/wxkf/music/' .$v,
									);
									$this -> replyMusic($postObj,$data);
								}else{
									$this -> replyText($postObj,'目前还没有这个编号哦！');
								}
								$i++;
							}
						}
					}else{
						$this -> replyText($postObj,$content);
					}
				break;
  			}
		}
		//回复文本
		public function replyText($postObj,$content){
			$xml = '<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%d</CreateTime>
				<MsgType><![CDATA[text]]></MsgType>
				<Content><![CDATA[%s]]></Content>
			</xml>';
			echo sprintf($xml,$postObj->FromUserName,$postObj->ToUserName,time(),$content);
		}

		//回复图片
		public function replyImage($postObj){
			$xml = '<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%d</CreateTime>
					<MsgType><![CDATA[image]]></MsgType>
					<Image>
					<MediaId><![CDATA[%s]]></MediaId>
					</Image>
				</xml>';
			echo sprintf($xml,$postObj->FromUserName,$postObj->ToUserName,time(),$postObj->MediaId);
		}
		//回复语音
		public function replyVoice($postObj){
			$xml = '<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%d</CreateTime>
						<MsgType><![CDATA[voice]]></MsgType>
						<Voice>
						<MediaId><![CDATA[%s]]></MediaId>
						</Voice>
					</xml>';
			echo sprintf($xml,$postObj->FromUserName,$postObj->ToUserName,time(),$postObj->MediaId);
		}
		//点击播放音乐
		public function replyMusic($postObj,$data){
			$xml = '<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%d</CreateTime>
						<MsgType><![CDATA[music]]></MsgType>
						<Music>
						<Title><![CDATA[%s]]></Title>
						<Description><![CDATA[%s]]></Description>
						<MusicUrl><![CDATA[%s]]></MusicUrl>
						<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
						</Music>
					</xml>';
			echo sprintf($xml,$postObj->FromUserName,$postObj->ToUserName,time(),$postObj->MediaId,$data['Title'],$data['Description'],$data['MusicUrl'],$data['HQMusicUrl']);
		}
		//回复图文消息
		public function replyNews($postObj,$data){
				foreach ($data as $key => $v) {
					$str .="<item>
								<Title><![CDATA[".$v[Title]."]]></Title>
								<Description><![CDATA[".$v[Description]."]]></Description>
								<PicUrl><![CDATA[".$v[PicUrl]."]]></PicUrl>
								<Url><![CDATA[".$v[Url]."]]></Url>
							</item>";
				}
				$xml = '<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%d</CreateTime>
							<MsgType><![CDATA[news]]></MsgType>
							<ArticleCount>'.count($data).'</ArticleCount>
							<Articles>
							'.$str.'
							</Articles>
						</xml> ';
				echo sprintf($xml,$postObj->FromUserName,$postObj->ToUserName,time());
		}
		//菜单点击事件
		public function checkClick($postObj,$EventKey){
			switch ($EventKey) {
				case 'NEWS':
					$data = array(
								array(
									'Title' =>'情感专区',
									'Description'=>'痛苦的呼唤',
									'PicUrl' => 'http://www.afefgrw.top/wxkf/image/a.png',
									'Url' => 'http://www.afefgrw.top/wxkf/jssdk/jssdk.php',
								),
								array(
									'Title' =>'男人的辛酸',
									'Description'=>'痛苦的呼唤',
									'PicUrl' => 'http://www.afefgrw.top/wxkf/image/b.png',
									'Url' => 'http://www.afefgrw.top/wxkf/jssdk/jssdk.php',
								),
								array(
									'Title' =>'努力勤奋',
									'Description'=>'痛苦的呼唤',
									'PicUrl' => 'http://www.afefgrw.top/wxkf/image/c.png',
									'Url' => 'http://www.baidu.com',
								),
							);
					$this -> replyNews($postObj,$data);
					break;
				case 'ZHOUDONG':
					break;
				case 'ZAN':
					$this -> replyText($postObj,'五杀超神不是梦！');
					break;
				default:
					break;
			}
		}

		//群发文本消息
		public function sendtext($text)
		{
			$url = "https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=".$this->get_access_token();
			// $arr = array(
			// 	 	"touser"=>,
			// 	   	"msgtype"=>"mpnews",
			// 	   	"text" => array("content" => $text);
			// );
		}
	}