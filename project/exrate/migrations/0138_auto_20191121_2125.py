# Generated by Django 2.2.2 on 2019-11-21 21:25

from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('exrate', '0137_auto_20191121_2115'),
    ]

    operations = [
        migrations.AlterField(
            model_name='bonus',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('fd2a7bc5-9911-49ff-b89a-0559b3c8c3b3'), null=True),
        ),
        migrations.AlterField(
            model_name='bonusdetail',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('9aa92a7d-2f36-41d5-a797-c8a429f3e23a'), null=True),
        ),
    ]
