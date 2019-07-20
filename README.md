# 封装Yaf框架的实现 #

## 1. 新建BaseController继承自Yaf_Controller_Abstract ##

## 2. Controller请继承自BaseController ##

## 3. BaseController介绍 ##

### 3.1 Request的操作 ###

对于Request的操作，直接使用$this->func()的方式调用，例如

判断访问类型

`$this->isGet();`
`$this->isPost();`

获取访问域名

`$this->getHost();`

获取客户端IP

`$this->getIp();`

获取Action名字

`$this->getActionName();`


### 3.2 参数的获取 ###

支持POST,GET,COOKIE,SERVER的字段获取
查询顺序如上
可以直接调用，不需要考虑访问类型
后续需要提供默认值，此版本不支持

`$this->getValue('var');`


### 3.3 访问的响应 ###

#### 3.3.1 view的控制 ####

hideView和showView
这两个方法封装了Yaf_dispatcher::getInstance()->enableView()的调用
可以直接在想要调用的地方调用

`$this->hideView();`

#### 3.3.2 模板与变量 #####

为了再次简化访问，这里借鉴了beego的方式
加入了两个变量，tplName和data
顾明思义，tplName就是模板名字，data就是数据
例如

`$this->setTplName('index2.phtml');`

`$this->setData(array('uname'=>'user1001'));`

#### 3.3.3 响应 ####
这里也是采用beego的方式
提供了serveJson和serveHtml的方式
根据前面的tplName和data，可以直接调用
serveJson会自动调用hideView，serveHtml会自动调用showView
也就是上面的view的控制也不需要主动调用
例如：

`$this->serveJson(array('errno'=>1000));`

就是一个api接口，返回{"errno":1000}给客户端

