# Generated by Django 2.2.2 on 2019-10-25 23:05

import datetime
from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('ds_exchange', '0009_auto_20191025_2302'),
    ]

    operations = [
        migrations.AlterField(
            model_name='dsorder',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 10, 28, 23, 4, 55, 984187)),
        ),
    ]
