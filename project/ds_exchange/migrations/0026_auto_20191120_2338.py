# Generated by Django 2.2.2 on 2019-11-20 23:38

import datetime
from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('ds_exchange', '0025_auto_20191120_2325'),
    ]

    operations = [
        migrations.AlterField(
            model_name='dsorder',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 11, 23, 23, 38, 12, 999715)),
        ),
    ]