# Generated by Django 2.2.2 on 2019-11-30 17:51

import datetime
from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('ds_exchange', '0047_auto_20191130_1750'),
    ]

    operations = [
        migrations.AlterField(
            model_name='dsorder',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 12, 3, 17, 51, 47, 139348)),
        ),
    ]
