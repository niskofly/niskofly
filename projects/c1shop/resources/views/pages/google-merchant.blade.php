<?
$sections_id = [
    1 => 2549,
    2 => 2612,
    5 => 2706,
    7 => 2706,
    9 => 2706,
    8 => 2706,
    3 => 5139,
    22 => 2849,
];
?>

<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
    <channel>
        <title>www.laundrypro.ru</title>
        <link>
        https://www.laundrypro.ru</link>
        <description>ООО «Вектор»</description>
        @foreach($products as $product)
            <?
            $product_photos = [];
            $params = [];
            $product_photos = explode(',', $product->photos);
            $product_photos = array_filter($product_photos);
            $params = unserialize($product->params);
            $sale_percent = 0;
            if ($product->old_price > 0) {
                $sale_percent = $product->actual_price * 100 / $product->old_price;
                $sale_percent = 100 - $sale_percent;
            }
            $vowels = ['laquo', 'nbsp',
                'raquo', 'Oslash', 'ldquo', 'rdquo', 'reg', 'times', 'ordm', 'ndash'];
            $section = array_key_exists($product->category()->id, $sections_id) ? $sections_id[$product->category()->id] : 1;
            ?>
            <item>
                <g:id>{{$product->id}}</g:id>
                <title>{{$product->name}}</title>

                <description>{{str_replace($vowels, "", strip_tags($product->description))}}</description>
                <link>
                https://www.laundrypro.ru/catalog/{{$product->category()->url}}/{{$product->url}}</link>
                <g:image_link>https://www.laundrypro.ru/{{$product->photo}}</g:image_link>
                @if(count($product_photos) > 0)
                    @foreach($product_photos as $more_photo)
                        <g:image_link>https://www.laundrypro.ru/{{$more_photo}}</g:image_link>
                    @endforeach
                @endif
                <g:availability>{{$product->in_stock ? 'in stock' : 'out of stock'}}</g:availability>
                <g:price>{{$product->actual_price}} RUB</g:price>
                <g:google_product_category>{{$section}}</g:google_product_category>
                <g:brand>{{$product->filterMark()->name}}</g:brand>
                <g:condition>new</g:condition>
            </item>
        @endforeach
    </channel>
</rss>