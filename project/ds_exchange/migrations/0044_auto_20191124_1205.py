# Generated by Django 2.2.2 on 2019-11-24 12:05

import datetime
from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('ds_exchange', '0043_auto_20191122_1513'),
    ]

    operations = [
        migrations.AlterField(
            model_name='dsorder',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 11, 27, 12, 5, 47, 789299)),
        ),
    ]
