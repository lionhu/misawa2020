# Generated by Django 2.2.2 on 2019-11-21 07:28

from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('exrate', '0132_auto_20191120_2338'),
    ]

    operations = [
        migrations.AlterField(
            model_name='bonus',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('472638ba-9552-4cb4-8203-397ae54131dd'), null=True),
        ),
        migrations.AlterField(
            model_name='bonusdetail',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('5946eaaa-05ab-447e-bae0-0855290a6f67'), null=True),
        ),
    ]