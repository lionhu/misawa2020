# Generated by Django 2.2.2 on 2019-11-19 22:13

import datetime
from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('mail_exchange', '0023_auto_20191119_2211'),
    ]

    operations = [
        migrations.AlterField(
            model_name='offer',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 11, 22, 22, 13, 32, 126836)),
        ),
        migrations.AlterField(
            model_name='offer',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('be87ba28-2240-4698-9cd2-1d5f585efe35'), null=True),
        ),
        migrations.AlterField(
            model_name='order',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 11, 22, 22, 13, 32, 125849)),
        ),
        migrations.AlterField(
            model_name='order',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('48eed285-675f-4575-a3c3-028a5ae6afa0'), null=True),
        ),
        migrations.AlterField(
            model_name='transaction',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('38ceb223-677a-4f85-aae4-9ce661b6c64b'), null=True),
        ),
    ]
