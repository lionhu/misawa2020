# Generated by Django 2.2.2 on 2019-11-22 09:48

import datetime
from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('ds_exchange', '0037_auto_20191121_2136'),
    ]

    operations = [
        migrations.AlterField(
            model_name='dsorder',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 11, 25, 9, 48, 20, 360807)),
        ),
    ]