from django.utils import timezone
from django.db import models
import datetime

# Create your models here.
class SstplUpData(models.Model):
    address = models.TextField( blank=True, null=True)  # Field name made lowercase.
    mac = models.CharField( max_length=200, blank=True, null=True)  # Field name made lowercase.
    time = models.DateTimeField( default=timezone.now, null=True)  # Field name made lowercase.
    freq = models.IntegerField(blank=True, null=True)
    modulation = models.CharField( max_length=100, blank=True, null=True)  # Field name made lowercase.
    data_rate = models.CharField( max_length=100, blank=True, null=True)  # Field name made lowercase.
    code_rate = models.CharField( max_length=100, blank=True, null=True)  # Field name made lowercase.
    rssi = models.IntegerField( blank=True, null=True)  # Field name made lowercase.
    lora_snr = models.FloatField( blank=True, null=True)  # Field name made lowercase.
    payload = models.TextField( blank=True, null=True)  # Field name made lowercase.
    port_no = models.CharField( max_length=20, blank=True, null=True)  # Field name made lowercase.

    class Meta:
        managed = True
        db_table = 'SSTPL_UP_Data'
        



        

class SstplDownData(models.Model):
   
    client_id= models.CharField(db_column='client_id',null=False,max_length=20)
    # time = models.DateTimeField(db_column='Time', null=True,default=datetime.datetime.now())
    time = models.DateTimeField(db_column='Time',default=timezone.now)
    deveui= models.CharField(db_column='deveui',null=False,max_length=16)
    command= models.CharField(db_column='command',null=False,max_length=512)
    class Meta:
        managed = True
        db_table = 'SSTPL_Down_Data'
        
class client_auth(models.Model):
    client_auth=models.CharField(max_length=255)
    c_password = models.CharField(max_length=50)
    client_id= models.CharField(db_column='client_id',null=False,max_length=20)
    
    class Meta:
        managed = True
        db_table = 'client_auth'