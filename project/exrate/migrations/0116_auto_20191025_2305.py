# Generated by Django 2.2.2 on 2019-10-25 23:05

from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('exrate', '0115_auto_20191025_2302'),
    ]

    operations = [
        migrations.AlterField(
            model_name='bonus',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('f1e2f221-725c-48dc-83dd-1fc21e8fb315'), null=True),
        ),
        migrations.AlterField(
            model_name='bonusdetail',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('eb4c1da7-8537-41af-9f94-39814ddb1704'), null=True),
        ),
    ]
