import requests
from urllib import parse
import logging
logger=logging.getLogger("error_logger")


#全局请求头
headers = {}
body = {}
timeouts = {}
resHeader = {}
url="https://connect.squareupsandbox.com/v2/"
ACCESS_TOKEN="EAAAEKq43mrNiHiJVdIIndwmWfzI2J9cR6zcjz-qrJuPRioMQ4-88RywvZg1xmA3"

class SquareApiRequest:
    def __init__(self):
        self.url = url
        self.ACCESS_TOKEN = ACCESS_TOKEN
        # body["showapi_appid"] = my_appId
        # body["showapi_sign"] = my_appSecret
        # headers["User-Agent"] = "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2427.7 Safari/537.36"
        # headers["Accept"]="application/json"
        # headers["Cache-Control"]="no-cache"
        headers["Content-Type"]="application/json"
        headers["Authorization"]="Bearer %s"%(ACCESS_TOKEN)


    def addHeadPara(self, key, value):
        headers[key] = value
        return self

    def addBodyPara(self, key, value):
        body[key] = value
        return self
    #设置连接时间和读取时间
    def setTimeout(self, connecttimout, readtimeout):
        timeouts["connecttimout"] = connecttimout
        timeouts["readtimeout"] = readtimeout
        return self


    def get(self):
        logger.error(self.url)
        logger.error(body)
        logger.error(headers)
        get_url = self.url + "?" + parse.urlencode(body)
        if not timeouts:
            res = requests.get(get_url, headers=headers)
        else:
            timeout = (timeouts["connecttimout"], timeouts["readtimeout"])
            res = requests.get(get_url, headers=headers, timeout=timeouts)
        return res

    def post(self):
        logger.error(self.url)
        logger.error(body)
        logger.error(headers)
        
        if not timeouts:
            res = requests.post(self.url,data=body, headers=headers)
        else:
            timeout = (timeouts["connecttimout"], timeouts["readtimeout"])
            res = requests.post(self.url,data=body, headers=headers, timeout=timeout)
        return res

    def payments(self,extension_url):
        amount_money={
          "amount": 100,
          "currency": "JPY"
        }
        body["idempotency_key"]="lionhu"
        body["autocomplete"]=True
        body["source_id"]="cnon:card-nonce-ok"
        body["amount_money"]=amount_money

        self.url += extension_url
        return self



