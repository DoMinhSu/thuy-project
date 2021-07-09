@extends('frontend.base')
@section('content')<section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="section-title">
                        <h4>{{ $text }}</h4>
                    </div>
                </div>
            </div>
            <div class="row property__gallery">
                @foreach ($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 mix women">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{ $product->image_picture }}">
                                {{-- <div class="label new">New</div> --}}
                                <ul class="product__hover">
                                    {{-- <li><a href="img/product/product-1.jpg" class="image-popup"><span
                                                class="arrow_expand"></span></a></li>
                                    <li><a href="#"><span class="icon_heart_alt"></span></a></li> --}}
                                    <li class="addToCart" data-id="{{ $product->id }}"><a href="#"><span
                                                class="icon_bag_alt"></span></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="#">{{ $product->name }}</a></h6>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="product__price">{{ $product->price }}$</div>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{ $products->links() }}
            </div>
        </div>
    </section>
@endsection
@push('scripts')

    <script>
        const addToCartButtons = document.getElementsByClassName('addToCart');
        const products = @json($products).data;
        const addToCartUrl = "{!! route('addToCart') !!}"
        Array.prototype.forEach.call(addToCartButtons, function(el) {
            el.addEventListener("click", async function(e) {
                e.preventDefault()
                if (quantity) {

                    const id = parseInt(this.getAttribute('data-id'));
                    try {
                        const result = await axios({
                            method: 'post',
                            url: addToCartUrl,
                            data: {
                                productId: id,
                                quantity: 1
                            }
                        });
                        console.log(result);
                        if (result.data > 0) {
                            const quantity = document.querySelector('#quantity');
                            quantity.innerText = result.data;
                        }

                    } catch (error) {
                        console.log(error);
                    }
                } else {
                    alert("Hãy đăng nhập để thêm sản phẩm vào giỏ hàng")
                }
            })
        });

    </script>
@endpush
