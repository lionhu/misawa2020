# Generated by Django 2.2.2 on 2019-11-21 21:15

import datetime
from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('ds_exchange', '0030_auto_20191121_2114'),
    ]

    operations = [
        migrations.AlterField(
            model_name='dsorder',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 11, 24, 21, 15, 20, 212116)),
        ),
    ]
