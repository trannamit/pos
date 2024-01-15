@extends('main')
@section('header')
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.27.2/axios.min.js"
        integrity="sha512-odNmoc1XJy5x1TMVMdC7EMs3IVdItLPlCeL5vSUPN2llYKMJ2eByTTAIiiuqLg+GdNr9hF6z81p27DArRFKT7A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
@section('content')
    @include('settings_page.css')
    <div id='app' class="container">
        <div v-for="(row,key) in data.data" class="row g-3 mb-3 align-items-center">
            <div class="col-4">
                <label class="col-form-label">@{{ row.title }}</label>
            </div>
            <div class="col-8" v-if="row.type === 'textarea'">
                <textarea v-model="data.data[key]['value']" class="form-control "> @{{ row.value }}</textarea>
            </div>
            <div class="col-8" v-else>
                <input v-model="data.data[key]['value']" v-on:change="btn[key] = 1" class="form-control" v-bind:type="row.type" v-bind:name="key"
                    v-bind:value="row.value">
            </div>

        </div>
        <div class="text-right">
            <button  v-on:click="saveSetting" class='btn btn-primary'>save</button>
        </div>
        <br>
    </div> 
    @include('settings_page.js')
@endsection
