# Generated by Django 2.2.2 on 2019-12-25 22:07

import datetime
from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('mail_exchange', '0062_auto_20191224_2337'),
    ]

    operations = [
        migrations.AlterField(
            model_name='offer',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 12, 28, 22, 7, 36, 917119)),
        ),
        migrations.AlterField(
            model_name='offer',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('74103902-2ddf-4db1-af5a-0e1c1aa2ed6e'), null=True),
        ),
        migrations.AlterField(
            model_name='order',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 12, 28, 22, 7, 36, 916040)),
        ),
        migrations.AlterField(
            model_name='transaction',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('5aa54089-1018-44cc-b6b5-0f437cbaba79'), null=True),
        ),
    ]