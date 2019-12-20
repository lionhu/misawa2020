# Generated by Django 2.2.2 on 2019-12-18 23:11

from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('exrate', '0160_auto_20191217_2313'),
    ]

    operations = [
        migrations.AddField(
            model_name='systemenv',
            name='env_type',
            field=models.CharField(blank=True, max_length=20, null=True),
        ),
        migrations.AlterField(
            model_name='bonus',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('336a5820-2f2a-42e4-aece-67d6ede40e45'), null=True),
        ),
        migrations.AlterField(
            model_name='bonusdetail',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('03dccb05-a924-401b-83dd-521f58ff2fc3'), null=True),
        ),
    ]