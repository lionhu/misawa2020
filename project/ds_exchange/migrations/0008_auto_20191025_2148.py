# Generated by Django 2.2.2 on 2019-10-25 21:48

import datetime
from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('ds_exchange', '0007_auto_20191025_2145'),
    ]

    operations = [
        migrations.AlterField(
            model_name='dsorder',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 10, 28, 21, 48, 34, 758763)),
        ),
    ]