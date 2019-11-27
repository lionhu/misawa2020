# Generated by Django 2.2.2 on 2019-11-21 21:14

import datetime
from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('mail_exchange', '0030_auto_20191121_2058'),
    ]

    operations = [
        migrations.AlterField(
            model_name='offer',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 11, 24, 21, 14, 52, 284202)),
        ),
        migrations.AlterField(
            model_name='offer',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('9f91b579-eddc-404a-9ea6-745b2c2dc102'), null=True),
        ),
        migrations.AlterField(
            model_name='order',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 11, 24, 21, 14, 52, 282885)),
        ),
        migrations.AlterField(
            model_name='order',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('cf7aa87d-a3be-4fbf-a85c-f12e40f17d08'), null=True),
        ),
        migrations.AlterField(
            model_name='transaction',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('e161dd82-79c2-4ed5-97a6-8c0654b4fab0'), null=True),
        ),
    ]