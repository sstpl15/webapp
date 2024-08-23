from django.contrib import admin
from django.urls import path
from . import views

urlpatterns = [
    
    path('',views.signin,name="signin"),
    # path('signup',views.signup,name="signup"),
    path('signin',views.signin,name="signin"),
    path('index',views.index,name="index"),
    path('signout',views.signout,name="signout"),
    path('login',views.login,name='login'),
    path('details',views.details,name="details"),
    path('search_mac',views.search_mac,name="search_mac"),
    path('search_eui',views.search_eui,name="search_eui"),
    path('date_search',views.date_search,name="date_search"),
    path('s_mac',views.s_mac,name="s_mac"),
    path('uplink/', views.uplink , name='uplink'),
    path('downlink/<str:devEUI>/<str:cmd>', views.downlink , name='downlink'),
    path('export_csv', views.export_csv , name='export_csv'),
    path('export_excel', views.export_excel , name='export_excel'),
    path('search_hour<int:id>', views.search_hour , name='search_hour'),
    path('gateways',views.gateways,name="gateways"),
    path('gatewayapi',views.gateway,name="gatewayapi"),
    # path('search',views.search,name="search"),
    
]
