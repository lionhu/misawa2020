# Generated by Django 2.2.2 on 2019-12-17 23:13

import datetime
from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('ds_exchange', '0053_auto_20191217_2312'),
    ]

    operations = [
        migrations.AlterField(
            model_name='dsorder',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 12, 20, 23, 13, 45, 812983)),
        ),
    ]