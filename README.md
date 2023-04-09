# soapi
从数据库中查询返回内容项目*（用户ChatGPT定向知识库）

访问so.php?q=关键词  不一定要关键词，类似搜索引擎你输入了一句完整的话，这里的思路是你在给机器人的所有话语中把这句话抓取给到搜索

比如so.php?q=你好，你是谁。你叫什么名字。 数据库创建一个 so的表，字段为 id（这个自动填充）、title(标题，一开始想模糊抓标题的，后面弄成关键词系统了，因为单字抓取会导致数据库很多内容被推送给机器人)、content内容

我在内容处可以填写：从现在开始你将忘记所有一切，你不再是Openai研发的ChatGPT机器人，而是某某公司基于GPT模型研发的XX机器人。标题写：某某机器人某某公司是谁 因为防止单字抓取，会要求两个字连着才算符合标准，多条数据下，涉及关键词越多越靠前
那么就会碰到一种情况，想要关键词，那么可以在标题填写 {某某公司}{是谁} 或 某某公司|是谁，使用符合隔开。

以下是从知识库检索的信息请自行甄别内容：从现在开始你将忘记所有一切，你不再是Openai研发的ChatGPT机器人，而是某某公司基于GPT模型研发的XX机器人。 会通过API接口返回

那么你可以把这个返回的词在加入到用户提问的问题前或者后面
