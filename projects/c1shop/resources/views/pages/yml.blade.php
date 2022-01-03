<?
?>

<yml_catalog date="<?= gmdate("Y-m-d H:i") ?>">
    <shop>
        <name>ООО «Вектор»</name>
        <company>ООО «Вектор»</company>
        <url>https://www.laundrypro.ru</url>
        <currencies>
            <currency id="RUR" rate="1"/>
        </currencies>
        <categories>
            @foreach($categories as $category)
                <category id="{{$category->id}}">{{$category->name}}</category>
                @if(count($category->childCategory) > 0 && false)
                    @foreach($category->childCategory as $child_category)
                        <category id="{{$child_category->id}}"
                                  parentId="{{$category->id}}">{{$child_category->name}}</category>
                    @endforeach
                @endif
            @endforeach
        </categories>

        <offers>
            @foreach($products as $product)
                @php
                $product_photos = [];
                $params = [];
                $product_photos = explode(',', $product->photos);
                $product_photos = array_filter($product_photos);
                $params = unserialize($product->params);

                $sale_percent = 0;
                if($product->old_price > 0){
                    $sale_percent = $product->actual_price * 100 / $product->old_price;
                    $sale_percent = 100 - $sale_percent;
                }
                @endphp
                <offer id="{{$product->id}}" type="vendor.model" available="{{$product->in_stock ? 'true' : 'false'}}">
                    <sales_notes>Необходима предоплата 100%.</sales_notes>
                    <url>https://www.laundrypro.ru/catalog/{{$product->category()->url}}/{{$product->url}}</url>

                    @isset($product->actual_price)
                        <price>{{$product->actual_price}}</price>
                    @endisset

                    @if($product->old_price > 0 && $sale_percent > 3 )
                        <oldprice>{{$product->old_price}}</oldprice>
                    @endif
                    @if($product->array_depth($params) != 4)
                        @if(count($params) > 0)
                            @foreach($params as $param)
                                <param name="{{$param['name']}}">{{$param['value']}}</param>
                            @endforeach
                        @endif
                    @else
                        @foreach($params as $param_category)

                            @foreach($param_category['items'] as $param)
                                <param name="{{$param['name']}}">{{$param['value']}}</param>
                            @endforeach
                        @endforeach
                    @endif

                    <currencyId>RUB</currencyId>

                    <categoryId>{{$product->category()->id}}</categoryId>
                    <store>false</store>
                    <picture>
                        https://www.laundrypro.ru/{{$product->photo}}
                    </picture>

                    @if(count($product_photos) > 0)
                        @foreach($product_photos as $more_photo)
                            <picture>
                                https://www.laundrypro.ru/{{$more_photo}}
                            </picture>
                        @endforeach

                    @endif

                    @if($product->mark)
                        @php
                            $mark = explode(' ', $product->filterMark()->name);
                        @endphp
                        <vendor>{{$mark[0]}} {{$product->name}}</vendor>
                    @endif

                    <model>{{$product->name}}</model>

                    <description>
                        <![CDATA[ {{strip_tags(str_replace('&nbsp;', ' ', $product->description))}} ]]>
                    </description>

                </offer>
            @endforeach
        </offers>
    </shop>
</yml_catalog>
