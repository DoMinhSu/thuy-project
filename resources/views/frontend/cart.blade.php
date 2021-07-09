@extends('frontend.base')
@section('content')

    <!-- Shop Cart Section Begin -->
    <section class="shop-cart spad">
        <div class="container">
            @if ($cart->isNotEmpty())
                <form action="{{ route('updateAllCart') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="shop__cart__table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cart as $item)
                                            <tr>
                                                <td class="cart__product__item">
                                                    {{-- <img src="{{$item->image}}" alt=""> --}}
                                                    <div class="cart__product__item__title">
                                                        <h6 data-id="{{ $item->id }}">{{ $item->name }}</h6>
                                                    </div>
                                                </td>
                                                <td class="cart__price">{{ $item->price }}</td>
                                                <td class="cart__quantity">
                                                    <div class="pro-qty">
                                                        <input type="text" class="quantity" name="quantity"
                                                            data-id="{{ $item->id }}" value="{{ $item->quantity }}">
                                                    </div>
                                                </td>
                                                <td class="cart__total">{{ $item->getPriceSum() }}</td>
                                                <td class="cart__close"><span class="icon_close"
                                                        data-id="{{ $item->id }}"></span></td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="cart__btn">
                                <a href="{{ route('index') }}">Continue Shopping</a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="cart__btn update__btn">
                                <a href="#" id="updateAllCart"><span class="icon_loading"></span> Update cart</a>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">

                    <form action="{{route('order')}}" class="checkout__form" style="display:block;width:100%;" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-8">
                                @guest('customers')
                                    <h5>Billing detail</h5>
                                    <div class="checkout__form__checkbox" id="haveaccount" style="cursor: pointer;">
                                        Have an acount?
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="checkout__form__input">
                                                <p>Name <span>*</span></p>
                                                <input type="text" name="customer[name]">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="checkout__form__input">
                                                <p>Số điện thoại <span>*</span></p>
                                                <input type="text" name="customer[phone_number]">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="checkout__form__input">
                                                <p>Address <span>*</span></p>
                                                <input type="text" placeholder="Address" name="customer[address]">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="checkout__form__input">
                                                <p>Oder notes <span>*</span></p>
                                                <input type="text" name="note"
                                                    placeholder="Có ghi chú thêm nếu cần thiết nhé!!">
                                            </div>
                                        </div>
                                    </div>
                                @endguest
                            </div>

                            <div class="col-lg-4">
                                <div class="checkout__order">
                                    <h5>Your order</h5>
                                    <div class="checkout__order__total">
                                        <ul>
                                            <li>Total <span>{{ $total }}</span></li>
                                        </ul>
                                    </div>
                                    <button type="submit" class="site-btn">Order</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <div>Hổng có sản phẩm nào ở đây hết bạn êi!!!</>
                @endisset

            </div>
</section>
<!-- Shop Cart Section End -->
@endsection()
@push('scripts')
<script>
    (function() {
        const quantities = document.getElementsByClassName('quantity')
        const cart__closeButtons = document.getElementsByClassName('icon_close');
        const updateAllCartButton = document.getElementById('updateAllCart');

        const deleteCartItem = "{!! route('deleteCartItem') !!}"
        const updateAllCartUrl = "{!! route('updateAllCart') !!}"

        let updateItemArray = []

        if (updateAllCartButton) {
            updateAllCartButton.addEventListener('click', async function(e) {
                e.preventDefault()
                Array.prototype.forEach.call(quantities, function(el) {
                    const id = parseInt(el.getAttribute('data-id'))
                    const quantity = parseInt(el.value)
                    const item = {
                        "id": id,
                        "quantity": quantity
                    }
                    updateItemArray.push(item)

                })
                try {
                    const result = await axios({
                        method: 'post',
                        url: updateAllCartUrl,
                        data: updateItemArray
                    });
                    if (result.data) {
                        window.location.reload()
                    }

                } catch (error) {
                    console.log(error);
                }
            })
        };

        Array.prototype.forEach.call(cart__closeButtons, async function(el) {
            el.addEventListener("click", async function(e) {
                e.preventDefault()
                const id = parseInt(this.getAttribute('data-id'));
                const parentOfCartItemElement = el.parentElement.parentElement;

                try {
                    const result = await axios({
                        method: 'delete',
                        url: deleteCartItem,
                        data: {
                            productId: id,
                        }
                    });
                    if (result.data >= 0) {
                        parentOfCartItemElement.remove()
                        quantity.innerText = result.data;
                        if (result.data === 0)
                            window.location.reload()


                    }

                } catch (error) {
                    console.log(error);
                }

            })
        });

        const haveaccount = document.getElementById('haveaccount')
        if (haveaccount) {
            haveaccount.addEventListener('click', function(e) {
                loginForm.trigger("reset");
                loginModal.modal()
            })
        }

    })()
</script>
@endpush
