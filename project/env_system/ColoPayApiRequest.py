import requests
from urllib import parse
import hashlib
import logging
logger=logging.getLogger("error_logger")


#全局请求头
headers = {}
body = {}
expireTime = 10
resHeader = {}
timeouts = {}
url="https://pay.colossaltech.jp/api/pay/pay/openCreate"
returnUrl="https://local.exrate.world:8443/"
ACCESS_TOKEN="1ouiyasdijasid"
SECRET_KEY="1asijdnjbpoasdp"
payType="02"

class ColoPayApiRequest:
    def __init__(self):
        self.url=url
        self.returnUrl=returnUrl
        self.expireTime=expireTime
        self.payType=payType
        self.SECRET_KEY=SECRET_KEY

        headers["Content-Type"]="application/json;charset=UTF-8"
        headers["X-CTGW-AccessToken"]=ACCESS_TOKEN

    def generateSignature(self,brandType,clientOrderNo,orderPrice,orderSubject):
        signatureStr  = "brandType="+str(brandType)+"&"
        signatureStr += "clientOrderNo="+str(clientOrderNo)+"&"
        signatureStr += "expireTime="+str(self.expireTime)+"&"
        signatureStr += "orderPrice="+str(orderPrice)+"&"
        signatureStr += "orderSubject="+str(orderSubject)+"&"
        signatureStr += "payType="+str(self.payType)+"&"
        signatureStr += "returnUrl="+self.returnUrl+"&"
        signatureStr += "key="+self.SECRET_KEY

        body["brandType"] = brandType
        body["clientOrderNo"] = clientOrderNo
        body["orderPrice"] = orderPrice
        body["orderSubject"] = orderSubject
        body["payType"] = self.payType
        body["returnUrl"] = self.returnUrl
        body["expireTime"] = self.expireTime

        signature=hashlib.md5(signatureStr.encode()).hexdigest().upper()
        headers["X-CTGW-Signature"]=signature
        return {
            "signatureStr":signatureStr,
            "signatureMD5":signature
        }

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
        print(self.url)
        print(body)
        print(headers)
        get_url = self.url + "?" + parse.urlencode(body)
        if not timeouts:
            res = requests.get(get_url, headers=headers)
        else:
            timeout = (timeouts["connecttimout"], timeouts["readtimeout"])
            res = requests.get(get_url, headers=headers, timeout=timeouts)
        return res

    def post(self):
        # logger.error(url)
        # logger.error(body)
        # logger.error(headers)

        # params={
        #     'brandType': '01', 
        #     'clientOrderNo': '2254808929160235', 
        #     'expireTime': 10, 
        #     'orderPrice': 999, 
        #     'orderSubject': 'テナントA商品', 
        #     'payType': '02', 
        #     'returnUrl': 'https://local.exrate.world:8443/'
        # }

        # Headers={
        #     'Content-Type': 'application/json;charset=UTF-8', 
        #     'X-CTGW-AccessToken': '1ouiyasdijasid', 
        #     'X-CTGW-Signature': 'F48A9386FA26C0BE8F0D11A507B8DA54'
        # }

        if not timeouts:
            res = requests.post(self.url,json=body, headers=headers)
        else:
            timeout = (timeouts["connecttimout"], timeouts["readtimeout"])
            res = requests.post(self.url,json=body, headers=headers, timeout=timeout)
        return res




