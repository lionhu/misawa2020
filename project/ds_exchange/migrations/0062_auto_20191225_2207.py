# Generated by Django 2.2.2 on 2019-12-25 22:07

import datetime
from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('ds_exchange', '0061_auto_20191224_2337'),
    ]

    operations = [
        migrations.AlterField(
            model_name='dsorder',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 12, 28, 22, 7, 36, 926864)),
        ),
    ]