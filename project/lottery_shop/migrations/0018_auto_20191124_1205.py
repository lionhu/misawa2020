# Generated by Django 2.2.2 on 2019-11-24 12:05

import django.contrib.postgres.fields.jsonb
from django.db import migrations


class Migration(migrations.Migration):

    dependencies = [
        ('lottery_shop', '0017_auto_20191122_1258'),
    ]

    operations = [
        migrations.AlterField(
            model_name='applicant',
            name='address',
            field=django.contrib.postgres.fields.jsonb.JSONField(blank=True, null=True),
        ),
    ]
