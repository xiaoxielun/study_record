# 学习笔记、学习资料整理

包括有php、linux、前端（html+css+js）、框架等等。

### 发布任务
通过该接口发布任务，请使用 `HTTP POST` 方式，请求数据 `json` 格式。

### api地址
http://jifen.yunhuiju.com/apiv1/task/publish

### 数据说明
|参数|说明|
|---|---|
|token|接口使用凭证|
|tasks|发布的任务数据|

### 请求数据举例

    {
      "token":"b805c8d379ee9a671541f1a2e48a771f",
      "tasks":[
        {
          "appleid":"appid",
          "keyword":"搜索词",
          "num":数量,
          "start_time":"开始时间",
          "sort":排名
        },
        {
          "appleid":"123456",
          "keyword":"app",
          "num":100,
          "start_time":"2019-01-01 12:00:00",
          "sort":1
        },
        ...
      ]
    }
