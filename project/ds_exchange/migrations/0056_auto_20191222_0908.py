# Generated by Django 2.2.2 on 2019-12-22 09:08

import datetime
from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('ds_exchange', '0055_auto_20191218_2311'),
    ]

    operations = [
        migrations.AlterField(
            model_name='dsorder',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 12, 25, 9, 8, 30, 238340)),
        ),
    ]
