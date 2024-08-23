from dotenv import load_dotenv
from django.shortcuts import redirect, render
from django.contrib.auth.models import User
from django.contrib import messages
from django.contrib.auth import authenticate, login, logout
from django.http import HttpResponse, HttpResponseRedirect
from django.views.decorators.cache import cache_control
from .models import SstplUpData, SstplDownData
from django.views.decorators.csrf import csrf_exempt
import json
import codecs
import base64
from datetime import datetime, timedelta
from django.http import JsonResponse
import requests
import os
import csv
import xlwt
domain='164.52.196.228'




def index(request):

    return render(request, 'app/index.html')


def s_mac(request):

    return render(request, 'app/s_mac.html')


def response_error_handler(request, exception=None):
    return render(request, 'app/404.html')


def signup(request):

    if request.method == 'POST':
        username = request.POST['username']
        fname = request.POST['fname']
        lname = request.POST['lname']

        email = request.POST['email']
        pass1 = request.POST['pass1']
        check = User
        if check.objects.filter(username=username).values():
            messages.error(request, "User name already exists")
            return redirect('signup')

        else:
            myuser = User.objects.create_user(username, email, pass1)
            myuser.first_name = fname
            myuser.last_name = lname

            myuser.save()
            messages.success(
                request, "Your account has been successfully created.")

            return redirect('signin')

    return render(request, 'app/signup.html')

# var global = {};
# global.settings = {
#     valid_start_date: a
#   };


def signin(request):

    if 'signin' in request.session:
        return redirect('details')
    elif request.method == 'POST':
        username = request.POST.get('username')
        pass1 = request.POST.get('pass1')

        user = authenticate(username=username, password=pass1)

        if user is not None:
            request.session['signin'] = username
            fname = user.first_name
            #print(fname)
            student = SstplUpData.objects.all().order_by('-id')[:500]
            #print(student)
            context = {
                'student': student
            }

            # return redirect('details')
            return render(request, 'app/details.html', context)
            # render(request, 'app/details.html',{'fname':fname,})

        else:
            messages.error(request, "Bad credentials!")
            # return redirect('index')

    return render(request, 'app/signin.html')


@cache_control(no_cache=True, must_revalidate=True)
def signout(request):
    del request.session['signin']
    messages.success(request, "Logged Out Successfully")
    return redirect('signin')


def details(request):
    if 'signin' in request.session:
        student = SstplUpData.objects.all().order_by('-id')[:500]
        #print(student)
        context = {
            'student': student
        }

        return render(request, 'app/details.html', context)
    else:
        return redirect('signin')
    
def gateways(request):
    if 'signin' in request.session:
        lora_login_url=f"http://{domain}"
        username="admin"
        password="V!ond@t2024"
        headers_login = {"Content-type": "application/x-www-form-urlencoded", "Accept":"text/plain"}
        ###las login and meter command####
        url_login = lora_login_url+":8080/api/internal/login"
        payload_login={"password":password,"email":username}
        payload_login=json.dumps(payload_login)
        print(payload_login)
        response = requests.post(url_login,data=payload_login,headers=headers_login,verify=False)
        #print("response is as ***",response.text)
        try:
            jwt=json.loads(response.text)
            print(jwt)
            token=jwt['jwt']
        except:
            payload_login={"password":password,"username":username}
            payload_login=json.dumps(payload_login)
            print(payload_login)
        response = requests.post(url_login,data=payload_login,headers=headers_login,verify=False)
        jwt=json.loads(response.text)
        print(jwt)
        token=jwt['jwt']
        print(token)
        headers = {"Content-type": "application/x-www-form-urlencoded", "Accept":"text/plain","Grpc-Metadata-Authorization":token}

        url = f"http://{domain}:8080/api/gateways?limit=100"

        payload={}

    
        response = requests.request("GET", url, headers=headers, data=payload)
        response_obj = json.loads(response.text)
        print(response_obj)
        context = {
            'data': response_obj
        }

        return render(request, 'app/gateway.html',context)
    else:
        return redirect('signin')


def search_mac(request):
    if request.POST:
        if request.POST['mac']:
            mac1 = request.POST.get('mac')
            #print('mac request', request.POST)
            posts = SstplUpData.objects.filter(mac=mac1).order_by('-id')[:50]
            #print(posts)
            context1 = {
                'posts': posts
            }
            return render(request, 'app/details.html', context1)

        return redirect('details')
    return redirect('details')


def search_eui(request):
    if request.POST:
        if request.POST['eui']:
            #print('eui', request.POST)
            eui1 = request.POST.get('eui')
            #print(type(eui1))
            post1 = SstplUpData.objects.filter(
                address=eui1).order_by('-id')[:50]
            #print(post1)
            context2 = {
                'post1': post1
            }
            return render(request, 'app/details.html', context2)
        return redirect('details')
    return redirect('details')


@csrf_exempt
def uplink(request):

    data=request.body
    print(data,'ffffffffffffffffffffffffff')

    # {'deduplicationId': 'fbdd440e-4cb6-4164-809b-aae66f041ef2', 'time': '2023-04-06T06:03:04.790811798+00:00', 'deviceInfo': {'tenantId': '52f14cd4-c6f1-4fbd-8f87-4025e1d49242', 'tenantName': 'ChirpStack', 'applicationId': '48e458c9-4f1d-4ca7-9fda-048f61ad5e3a', 'applicationName': 'test', 'deviceProfileId': '7c87c175-e256-48de-885b-244c9a326ffd', 'deviceProfileName': 'dev_pro_abp_c', 'deviceName': 'node_506f980000000404', 'devEui': '506f980000000404', 'tags': {}}, 'devAddr': '00000404', 'adr': True, 'dr': 3, 'fCnt': 0, 'fPort': 7, 'confirmed': True, 'data': 'U1NUUEz/////ABMB', 'rxInfo': [{'gatewayId': '506f980000000001', 'uplinkId': 23495, 'rssi': -88, 'snr': 0.5, 'channel': 4, 'rfChain': 1, 'location': {}, 'context': 'eSxWfA==', 'metadata': {'region_common_name': 'IN865', 'region_config_id': 'in865'}, 'crcStatus': 'CRC_OK'}], 'txInfo': {'frequency': 865985000, 'modulation': {'lora': {'bandwidth': 125000, 'spreadingFactor': 9, 'codeRate': 'CR_4_5'}}}}

    obj=json.loads(data)
    print(obj)
    # devEUI=obj['devEUI']
    # gw=obj['rxInfo'][0]['gatewayID']
    try:
        devEUI = base64.b64decode(obj['devEUI']).hex()
        gw = base64.b64decode(obj['rxInfo'][0]['gatewayID']).hex()
        if devEUI[0:6]=="506f98":
            pass
        else:
            devEUI = obj['devEUI']
            gw = obj['rxInfo'][0]['gatewayID']

    except:
        devEUI = obj['devEUI']
        gw = obj['rxInfo'][0]['gatewayID']
    print('***********************************gw',gw,devEUI)
    fq=obj['txInfo']['frequency']
    try:
        sf=obj['txInfo']['loRaModulationInfo']['spreadingFactor']
    except:
        sf='10'
    fcnt=obj['fCnt']
    modu=obj['applicationName']
    rssi=obj['rxInfo'][0]['rssi']
    snr=obj['rxInfo'][0]['loRaSNR']
    payload=base64.b64decode(obj['data']).hex()
    send_time = datetime.now()
    ##print('current time is as ',send_time)
    a = SstplUpData(address=devEUI,payload=payload, mac=gw, freq=fq,
                    modulation=modu, rssi=rssi, lora_snr=snr, code_rate=fcnt, data_rate=sf)
    a.save()
    return HttpResponse("uplink saved")
        ############ send raw data on third party api #########

        
    

@csrf_exempt
def downlink(request,devEUI,cmd):
    # devEUI='506f980000000404'
    #print(devEUI,cmd)
    url = f"http://{domain}:8080/api/devices/"+devEUI+"/queue"

    command='001100'
    b64 = codecs.encode(codecs.decode(command, 'hex'), 'base64').decode()
    payload = json.dumps({
    "queueItem": {
        "confirmed": True,
        "data": b64,
        "fCntDown": 0,
        "fPort": 7,
        "id": "string",
        "isPending": True,
        "object": {}
    }
    })
    headers = {
    'Authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJjaGlycHN0YWNrIiwiaXNzIjoiY2hpcnBzdGFjayIsInN1YiI6IjU0NDA4ZmJjLTExNjUtNGIxZC04NDQ1LTgyZGNiMGUwY2ZiOCIsInR5cCI6ImtleSJ9.tBJoTVR35jUznC6xZ4iIiJMBD6eeNr4lLTHgkVLGtz4',
    'Content-Type': 'application/json'
    }

    response = requests.request("POST", url, headers=headers, data=payload)
    #print('dsjgfisdujhbfosabdosauhdoahdoiuhoiuhgouhoho')
    #print(response.text)
            
# downlink()


def export_csv(request):
    response = HttpResponse(content_type='text/csv')
    response['Content-Disposition'] = 'attachment;filename=Data' +\
        str(datetime.now())+'.csv'

    writer = csv.writer(response)
    writer.writerow(['DeviceEUI', 'Gateway MACAddress', 'Time', 'Freq',
                    'ApplicationName', 'SF', 'fcnt', 'RSSI', 'SNR', 'Payload'])

    data1 = SstplUpData.objects.all().order_by('-id')[:500]

    for data in data1:
        writer.writerow([data.address, data.mac, data.time, data.freq, data.modulation,
                        data.data_rate, data.code_rate, data.rssi, data.lora_snr, data.payload])
    return response


def export_excel(request):
    response = HttpResponse(content_type='application/ms-excel')
    response['Content-Disposition'] = 'attachment;filename=Data' +\
        str(datetime.now())+'.xls'

    wb = xlwt.Workbook(encoding='utf-8')
    ws = wb.add_sheet('data')
    row_num = 0
    # font_style=xlwt.XFstyle()
    # font = xlwt.Font()
    # font.bold = True
    # font_style.font = font

    coloumns = (['DeviceEUI', 'Gateway MACAddress', 'Time', 'Freq',
                'ApplicationName', 'SF', 'fcnt', 'RSSI', 'SNR', 'Payload', ])

    for col_num in range(len(coloumns)):
        ws.write(row_num, col_num, coloumns[col_num])

    # font_style=xlwt.Xstyle()
    rows = SstplUpData.objects.all().order_by('-id')[:50000].values_list(
        'address', 'mac', 'time', 'freq', 'modulation', 'data_rate', 'code_rate', 'rssi', 'lora_snr', 'payload')

    for row in rows:
        row_num += 1

        for col_num in range(len(row)):
            ws.write(row_num, col_num, str(row[col_num]))
    wb.save(response)
    return response


def date_search(request):
    
    if request.POST:
        if request.method=='POST':
                datef=request.POST['date1']
                #print(datef)
                datet=request.POST['date2']
                today_start = datetime.strptime(datef, '%Y-%m-%dT%H:%M')
                #print('********************************************',today_start)
                today_end = datetime.strptime(datet, '%Y-%m-%dT%H:%M')
                try:
                    t=SstplUpData.objects.filter(time__gte=today_start).filter(time__lte=today_end)
                    #print(t)
                    response = HttpResponse(content_type='application/ms-excel')
                    response['Content-Disposition'] = 'attachment;filename=Data' +\
                        str(datetime.now())+'.xls'

                    wb = xlwt.Workbook(encoding='utf-8')
                    ws = wb.add_sheet('data')
                    row_num = 0
                    # font_style=xlwt.XFstyle()
                    # font = xlwt.Font()
                    # font.bold = True
                    # font_style.font = font

                    coloumns = (['DeviceEUI', 'Gateway MACAddress', 'Time', 'Freq',
                                'ApplicationName', 'SF', 'fcnt', 'RSSI', 'SNR', 'Payload', ])

                    for col_num in range(len(coloumns)):
                        ws.write(row_num, col_num, coloumns[col_num])

                    # font_style=xlwt.Xstyle()
                    rows = SstplUpData.objects.filter(time__gte=today_start).filter(time__lte=today_end).values_list(
                        'address', 'mac', 'time', 'freq', 'modulation', 'data_rate', 'code_rate', 'rssi', 'lora_snr', 'payload')

                    for row in rows:
                        row_num += 1

                        for col_num in range(len(row)):
                            ws.write(row_num, col_num, str(row[col_num]))
                    wb.save(response)
                    return response
                except:
                    t=None
                    
                context2 = {
                'post2': t
            }
        return render(request, 'app/details.html', context2)
        return redirect('details')
    return redirect('details')


def search_hour(request,id):
    datef=id
    #print('***********************************************************************',datef)
    try:
        time_threshold = datetime.now() - timedelta(hours=id)
        t=SstplUpData.objects.filter(time__gt=time_threshold)
        #print('***********************************************************************',t)
        context2 = {
                'post3': t
            }
        return render(request, 'app/details.html', context2)
    except:
        return redirect('details')
    return redirect('details')

def gateway(request):
    print('assssssssssssssssssssssssssssssssssssssssssssssssss')
    lora_login_url=f"http://{domain}"
    username="admin"
    password="V!ond@t2024"
    headers_login = {"Content-type": "application/x-www-form-urlencoded", "Accept":"text/plain"}
    ###las login and meter command####
    url_login = lora_login_url+":8080/api/internal/login"
    payload_login={"password":password,"email":username}
    payload_login=json.dumps(payload_login)
    print(payload_login)
    response = requests.post(url_login,data=payload_login,headers=headers_login,verify=False)
    #print("response is as ***",response.text)
    try:
        jwt=json.loads(response.text)
        print(jwt)
        token=jwt['jwt']
    except:
        payload_login={"password":password,"username":username}
        payload_login=json.dumps(payload_login)
        print(payload_login)
    response = requests.post(url_login,data=payload_login,headers=headers_login,verify=False)
    jwt=json.loads(response.text)
    print(jwt)
    token=jwt['jwt']
    print(token)
    headers = {"Content-type": "application/x-www-form-urlencoded", "Accept":"text/plain","Grpc-Metadata-Authorization":token}
    url = f"http://{domain}:8080/api/gateways?limit=100"

    payload={}


   
    response = requests.request("GET", url, headers=headers, data=payload)
    response_obj = json.loads(response.text)
    print(response_obj)
    return JsonResponse(response_obj, safe=False)
    
    