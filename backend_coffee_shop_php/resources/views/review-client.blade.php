<x-layout-review>
    <div class="container px-3 mt-5">

        <h2 class="font-bold mb-4 text-white text-capitalize"> {{ __('t.leave_a_review') ?? 'leave a review' }} </h2>

        <x-alert></x-alert>

        <form action="{{ route('reviews.store') }}" method="POST" class="space-y-4" id="review-form">
            @csrf

            <div class="mb-3 mt-3 input-group-sm">
                <label for="name" class="form-label text-light mb-2 text-capitalize"> {{ __('t.name') ?? "name" }}
                </label>
                <input type="text" class="form-control" value="" id="name"
                    placeholder="{{ __('t.enter_name') ?? "enter name" }}" name="name">
            </div>

            <div class="mb-3 mt-3 input-group-sm">
                <label for="name" class="form-label text-light mb-2 text-capitalize"> {{ __('t.phone') ?? "phone" }}
                </label>
                <input type="text" class="form-control" value="" id="phone"
                    placeholder="{{ __('t.enter_phone') ?? "enter phone" }}" name="phone">
            </div>

            <div class="mb-3 mt-3 input-group-sm">
                <label for="rating" class="form-label text-light mb-2 text-capitalize"> {{ __('t.rating') ?? "rating" }}
                </label>
                <div class="star-rating" id="star-rating">
                    <span class="star" data-value="5">★</span>
                    <span class="star" data-value="4">★</span>
                    <span class="star" data-value="3">★</span>
                    <span class="star" data-value="2">★</span>
                    <span class="star" data-value="1">★</span>
                </div>

                <input type="hidden" name="rating" id="rating" value="0">
            </div>

            <div class="mb-3 mt-3 input-group-sm">
                <label for="name" class="form-label text-light mb-2 text-capitalize"> {{ __('t.comment') ?? "comment" }}
                </label>

                <textarea class="form-control" rows="5" id="comment" name="comment"></textarea>
            </div>

            <div class="input-group-sm d-grid">
                <button type="submit" class="btn btn-primary mt-2 text-capitalize">
                    {{ __('t.add_review') ?? "add review" }} </button>
            </div>
        </form>
        <p class="text-white text-info-review mt-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque et ut, at itaque deserunt accusamus. Saepe a possimus cumque error.</p>
    </div>

</x-layout-review>
