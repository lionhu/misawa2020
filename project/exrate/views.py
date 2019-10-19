from django.shortcuts import render
from datetime import datetime,timedelta 
from env_system.ShowapiRequest import ShowapiRequest
import json


# Create your views here.

def BOC_Rate_history(dt_start,dt_end):
    r = ShowapiRequest("http://route.showapi.com/1683-2","76812","ff6b110b4d884acf9d1ddc030a16c5a0" )
    r.addBodyPara("code", "JPYCNY")
    r.addBodyPara("begin", dt_start)
    r.addBodyPara("end", dt_end)
    res = r.post()

    data=json.loads(res.text)

    fetch_error = data["showapi_res_error"]

    if  not fetch_error:
      rates=data["showapi_res_body"]["codeList"]

      return rates

    return None
