# Generated by Django 2.2.2 on 2019-12-22 17:06

import datetime
from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('ds_exchange', '0056_auto_20191222_0908'),
    ]

    operations = [
        migrations.AlterField(
            model_name='dsorder',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 12, 25, 17, 6, 25, 543230)),
        ),
    ]
