# Generated by Django 2.2.2 on 2019-12-29 10:04

import datetime
from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('ds_exchange', '0063_auto_20191228_1137'),
    ]

    operations = [
        migrations.AlterField(
            model_name='dsorder',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2020, 1, 1, 10, 4, 52, 263629)),
        ),
    ]