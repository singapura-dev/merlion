<div class="alert alert-{{$type}}" role="alert">
    @if(!empty($title))
        <h4 class="alert-heading">{{$title}}</h4>
    @endif
    @if(isset($content))
        <div class="alert-description">
            {{$content}}
        </div>
    @endif
</div>
