@extends('layouts.app')
<!doctype html>
<html lang="en">
    <head>
        <title>Registrar Activo</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
        <link href="{{asset('assets/estiloLogin.css')}}" rel="stylesheet">

        <!-- Select2 -->
        <link rel="stylesheet" href="vendor/adminlte/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="vendor/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <script data-cfasync="false" nonce="2823c135-4b84-4a99-b748-a0ec6bd3fac9">try{(function(w,d){!function(a,b,c,d){if(a.zaraz)console.error("zaraz is loaded twice");else{a[c]=a[c]||{};a[c].executed=[];a.zaraz={deferred:[],listeners:[]};a.zaraz._v="5848";a.zaraz._n="2823c135-4b84-4a99-b748-a0ec6bd3fac9";a.zaraz.q=[];a.zaraz._f=function(e){return async function(){var f=Array.prototype.slice.call(arguments);a.zaraz.q.push({m:e,a:f})}};for(const g of["track","set","debug"])a.zaraz[g]=a.zaraz._f(g);a.zaraz.init=()=>{var h=b.getElementsByTagName(d)[0],i=b.createElement(d),j=b.getElementsByTagName("title")[0];j&&(a[c].t=b.getElementsByTagName("title")[0].text);a[c].x=Math.random();a[c].w=a.screen.width;a[c].h=a.screen.height;a[c].j=a.innerHeight;a[c].e=a.innerWidth;a[c].l=a.location.href;a[c].r=b.referrer;a[c].k=a.screen.colorDepth;a[c].n=b.characterSet;a[c].o=(new Date).getTimezoneOffset();if(a.dataLayer)for(const k of Object.entries(Object.entries(dataLayer).reduce(((l,m)=>({...l[1],...m[1]})),{})))zaraz.set(k[0],k[1],{scope:"page"});a[c].q=[];for(;a.zaraz.q.length;){const n=a.zaraz.q.shift();a[c].q.push(n)}i.defer=!0;for(const o of[localStorage,sessionStorage])Object.keys(o||{}).filter((q=>q.startsWith("_zaraz_"))).forEach((p=>{try{a[c]["z_"+p.slice(7)]=JSON.parse(o.getItem(p))}catch{a[c]["z_"+p.slice(7)]=o.getItem(p)}}));i.referrerPolicy="origin";i.src="/cdn-cgi/zaraz/s.js?z="+btoa(encodeURIComponent(JSON.stringify(a[c])));h.parentNode.insertBefore(i,h)};["complete","interactive"].includes(b.readyState)?zaraz.init():a.addEventListener("DOMContentLoaded",zaraz.init)}}(w,d,"zarazData","script");window.zaraz._p=async bs=>new Promise((bt=>{if(bs){bs.e&&bs.e.forEach((bu=>{try{const bv=d.querySelector("script[nonce]"),bw=bv?.nonce||bv?.getAttribute("nonce"),bx=d.createElement("script");bw&&(bx.nonce=bw);bx.innerHTML=bu;bx.onload=()=>{d.head.removeChild(bx)};d.head.appendChild(bx)}catch(by){console.error(`Error executing script: ${bu}\n`,by)}}));Promise.allSettled((bs.f||[]).map((bz=>fetch(bz[0],bz[1]))))}bt()}));zaraz._p({"e":["(function(w,d){})(window,document)"]});})(window,document)}catch(e){throw fetch("/cdn-cgi/zaraz/t"),e;};</script></head>

    @section('content')
        <section class="h-100 gradient-form" style="background-color: #eee;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-xl-10">
                        <div class="card rounded-3 text-black">
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <div class="card-body p-md-5 mx-md-4">
                                        <div class="text-center">
                                            <img src="{{asset('pictures/Logo Empresas Iansa.png')}}"
                                                style="width: 300px;" alt="logo">
                                        </div>

                                        <h2>Registrar nuevo activo</h2>

                                        <form action="/activos" method="POST">
                                            @csrf

                                            <!-- Nro Serie -->
                                            <div data-mdb-input-init class="form-outline mb-4">
                                                <label class="form-label" for="nroSerie">Nro. Serie</label>
                                                <input type="text" name="nroSerie" id="nroSerie" required class="form-control" />
                                            </div>

                                            <!-- Marca -->
                                            <div data-mdb-input-init class="form-outline mb-4">
                                                <label class="form-label" for="marca">Marca</label>
                                                <input type="text" name="marca" id="marca" required class="form-control" />
                                            </div>

                                            <!-- Modelo -->
                                            <div data-mdb-input-init class="form-outline mb-4">
                                                <label class="form-label" for="modelo">Modelo</label>
                                                <input type="text" name="modelo" id="modelo" required class="form-control" />
                                            </div>

                                            <!-- Tipo de Activo -->
                                            <div data-mdb-input-init class="form-outline mb-4">
                                                <label class="form-label" for="tipoActivo">Tipo de Activo</label>
                                                <select name="tipoActivo" id="tipoActivo" class="form-control" required>
                                                    <option value="LAPTOP">Laptop</option>
                                                    <option value="DESKTOP">Desktop</option>
                                                    <option value="MONITOR">Monitor</option>
                                                    <option value="IMPRESORA">Impresora</option>
                                                    <option value="CELULAR">Celular</option>
                                                    <option value="OTRO">Otro</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Multiple</label>
                                                <select name="accesorios[]" id="accesorios" class="select2bs4" multiple="multiple" data-placeholder="Select a State"
                                                        style="width: 100%;">
                                                    <option value="docking">Docking</option>
                                                    <option value="parlanteJabra">Parlante Jabra</option>
                                                    <option value="discoDuroExte">Disco Duro Externo</option>
                                                    <option value="impresoraExclusiva">Impresora Exclusiva</option>
                                                    <option value="monitor">Monitor</option>
                                                    <option value="mouse">Mouse</option>
                                                    <option value="teclado">Teclado</option>
                                                </select>
                                            </div>

                                            <!-- Justificación Doble Activo -->
                                            <div data-mdb-input-init class="form-outline mb-4">
                                                <label class="form-label" for="justificacionDobleActivo">Justificación de Doble Activo (opcional)</label>
                                                <textarea name="justificacionDobleActivo" id="justificacionDobleActivo" class="form-control"></textarea>
                                            </div>

                                            <!-- Precio -->
                                            <div data-mdb-input-init class="form-outline mb-4">
                                                <label class="form-label" for="precio">Precio</label>
                                                <input type="number" name="precio" id="precio" required class="form-control" />
                                            </div>

                                            <!-- Botón de Enviar -->
                                            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Registrar Activo</button>
                                        </form>

                                        <a href="/dashboard" type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-danger">Volver atrás</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection
</html>
