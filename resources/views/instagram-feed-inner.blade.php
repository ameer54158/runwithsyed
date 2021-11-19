@if(count($feed))
    @foreach($feed as $post)
        <div class="col-lg-4 col-md-6 col-6 pb-2 container-section">
            <a href="{{isset($post['permalink']) && $post['permalink'] ? $post['permalink'] : '#'}}" target="_blank">
                <div class="img-section">
                    @if(isset($post['url']) && $post['url'] && isset($post['type']) && $post['type'] == 'image')
                        <img class="img-fluid" src="{{ isset($post['url']) && $post['url'] ? $post['url'] : asset('public/images/no-image.png')}}">
                    @elseif(isset($post['url']) && $post['url'] && isset($post['type']) && $post['type'] == 'video')
                        <video src="{{$post['url']}}" style="width:100%; height: 100%;border-radius: 10px;">
                        </video>
                    @endif
                </div>
                <div class="centered">
                    @if(isset($post['timestamp']) && $post['timestamp'])
                        <div class="date @if(!isset($post['caption']) || !$post['caption']) border-0 p-0 m-0 @endif">
                            {{date('M d, Y',strtotime($post['timestamp']))}}
                        </div>
                    @endif

                    @if(isset($post['caption']) && $post['caption'])
                        <div class="caption">
                            {{Str::limit($post['caption'],50)}}
                        </div>
                    @endif
                </div>
            </a>
        </div>
    @endforeach
@endif