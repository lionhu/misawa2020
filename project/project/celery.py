from __future__ import absolute_import, unicode_literals
import os
from celery import Celery
from django.conf import settings
from datetime import timedelta
from celery.schedules import crontab
from django.utils import timezone
from kombu import Exchange
from kombu import Queue
import datetime
import pytz

os.environ.setdefault('DJANGO_SETTINGS_MODULE', 'project.settings')

app = Celery('project', broker='amqp://celery:password123@rabbitmq:5672/my_vhost',
	backend='amqp://celery:password123@rabbitmq:5672/my_vhost')

app.config_from_object('django.conf:settings', namespace='CELERY')
# app.now = timezone.now
now = datetime.datetime.now()
# here, now.tzinfo is None, it's a naive datetime
now = pytz.utc.localize(now)


# 设置了三个Queue绑定到一个direct类型的exchange上,然后consumer监听所有的队列,消息来了后就轮询调用consumer进行处理.
task_exchange = Exchange('tasks', type='direct')
# 异步任务优先级
task_queues = [Queue('hipri', task_exchange, routing_key='hipri'),
               Queue('midpri', task_exchange, routing_key='midpri'),
               Queue('lopri', task_exchange, routing_key='lopri')]

app.autodiscover_tasks(lambda: settings.INSTALLED_APPS)

timezone = 'Asia/Tokyo'


