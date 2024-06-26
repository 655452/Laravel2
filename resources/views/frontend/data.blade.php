
@foreach($restaurants as $post)
    <div>
        <h3><a href="">{{ $post->name }}</a></h3>
        <p>{{  \Illuminate\Support\Str::limit($post->description, 400) }}</p>

        <div class="text-right">
            <button class="btn btn-success">{{__('frontend.read_more')}}</button>
        </div>

        <hr class="margin-top-5">
    </div>
@endforeach
