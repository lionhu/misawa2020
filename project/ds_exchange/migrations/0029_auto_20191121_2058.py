# Generated by Django 2.2.2 on 2019-11-21 20:58

import datetime
from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('ds_exchange', '0028_auto_20191121_0839'),
    ]

    operations = [
        migrations.AlterField(
            model_name='dsorder',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 11, 24, 20, 58, 13, 529106)),
        ),
    ]
