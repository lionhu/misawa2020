# Generated by Django 2.2.2 on 2019-10-27 13:02

import datetime
from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('ds_exchange', '0010_auto_20191025_2305'),
    ]

    operations = [
        migrations.AlterField(
            model_name='dsorder',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 10, 30, 13, 2, 42, 361028)),
        ),
    ]
