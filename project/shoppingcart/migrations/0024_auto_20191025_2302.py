# Generated by Django 2.2.2 on 2019-10-25 23:02

import django.contrib.postgres.fields.jsonb
from django.db import migrations


class Migration(migrations.Migration):

    dependencies = [
        ('shoppingcart', '0023_auto_20191025_2148'),
    ]

    operations = [
        migrations.AlterField(
            model_name='order',
            name='cartjson',
            field=django.contrib.postgres.fields.jsonb.JSONField(blank=True, default={}, null=True),
        ),
    ]