# Generated by Django 2.2.2 on 2019-11-11 09:49

import datetime
from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('mail_exchange', '0014_auto_20191107_2230'),
    ]

    operations = [
        migrations.AlterField(
            model_name='offer',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 11, 14, 9, 49, 34, 334291)),
        ),
        migrations.AlterField(
            model_name='offer',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('71e57a5e-44e9-4997-8665-f4dbc5182f51'), null=True),
        ),
        migrations.AlterField(
            model_name='order',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 11, 14, 9, 49, 34, 333147)),
        ),
        migrations.AlterField(
            model_name='order',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('9426ff00-b3d1-4700-849b-87ba518ed289'), null=True),
        ),
        migrations.AlterField(
            model_name='transaction',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('a26b41a8-a96c-4a4e-bbae-3d86404910a5'), null=True),
        ),
    ]
