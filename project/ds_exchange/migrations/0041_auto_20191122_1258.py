# Generated by Django 2.2.2 on 2019-11-22 12:58

import datetime
from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('ds_exchange', '0040_auto_20191122_1004'),
    ]

    operations = [
        migrations.AlterField(
            model_name='dsorder',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 11, 25, 12, 58, 10, 798883)),
        ),
    ]
