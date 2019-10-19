@extends("layouts.master")

@section("main_content")
    <div class="container clearfix" id="app">
        <tabs>

            <tab name="About Our Culture" :selected="true">
                <h1>Here is the content for the about our culture tab.</h1>
            </tab>

            <tab name="About Our Vision">
                <h1>Here is the content for the about our vision tab.</h1>
            </tab>

            <tab name="About US">
                <h1>Here is the content for the about US.</h1>
            </tab>
        </tabs>

        <ul>
            <li v-for="user in users">
                @{{user.name | catpitalizeFirst}}
            </li>
        </ul>

        <input type="text" v-model="message">
        <button @click="send2Server">Send</button>
    </div>
@endsection

@section("foot_scripts")
    <script src="{{asset('js/tabs.js')}}"></script>
@endsection