# Generated by Django 2.2.2 on 2019-11-11 09:49

import datetime
from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('ds_exchange', '0013_auto_20191107_2230'),
    ]

    operations = [
        migrations.AlterField(
            model_name='dsorder',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 11, 14, 9, 49, 34, 342881)),
        ),
    ]
