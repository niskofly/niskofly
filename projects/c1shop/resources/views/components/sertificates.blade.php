@php
    $Sertificates = App\Models\Sertificate::active()->sort()->get();
@endphp

<div class="b-o-kompanii-doc">
    <div class="b-o-kompanii-doc__photo js-popup-gallery">

        @foreach($Sertificates as $Sertificate)
            <a href="{{$Sertificate->photo}}" title="{{$Sertificate->name}}" class="img js-popup-photo">
                <img src="{{$Sertificate->photo}}" alt="{{$Sertificate->name}}">
            </a>
        @endforeach
    </div>
</div>