# Generated by Django 2.2.2 on 2019-11-21 08:39

from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('exrate', '0133_auto_20191121_0728'),
    ]

    operations = [
        migrations.AlterField(
            model_name='bonus',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('448fdeaa-190c-4776-b9fb-ab15be3ff1a9'), null=True),
        ),
        migrations.AlterField(
            model_name='bonusdetail',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('8a0408b3-afb2-4889-b125-a71f04cd1f30'), null=True),
        ),
    ]