<?php

/**
 * @var \App\Models\Product $Product
 */

?>
<script type="application/ld+json">
    {
        "@context": "http://schema.org/",
        "@type": "Product",
        "name": "{{$Product->name}}",
        "image": "http://www.laundrypro.ru/{{$Product->photo}}",
        "description": "{{ str_replace(array("\r\n", "\r", "\n"), '', strip_tags($Product->description)) }}",
        "mpn": "{{$Product->id}}",
        @if($Product->mark)
        @php
            $mark = explode(' ', $Product->filterMark()->name);
        @endphp
        "brand": {
            "@type": "Brand",
            "name": "{{$mark[0]}}"
        },
        @endif
        "offers": {
            "@type": "Offer",
            "priceCurrency": "RUB",
            "price": "{{$Product->actual_price}}",
            "itemCondition": "http://schema.org/UsedCondition",
            "availability": "http://schema.org/InStock",
            "seller": {
                "@type": "Organization",
                "name": "Вектор"
            }
        }
    }
</script>
