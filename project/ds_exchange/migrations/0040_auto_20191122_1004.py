# Generated by Django 2.2.2 on 2019-11-22 10:04

import datetime
from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('ds_exchange', '0039_auto_20191122_1002'),
    ]

    operations = [
        migrations.AlterField(
            model_name='dsorder',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 11, 25, 10, 4, 25, 925632)),
        ),
    ]
