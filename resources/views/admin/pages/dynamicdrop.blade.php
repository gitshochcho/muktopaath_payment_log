<select class="form-select" id="batch_course" name="course_batch" aria-label="Floating label select example">
    <option selected disabled>All</option>
    @forelse ($courseBatches as $courseBatch)
    <option value="{{$courseBatch->id}}" {{ request()->query('course_batch') == $courseBatch->id ? 'selected' : '' }}>{{$courseBatch?->title ?? $courseBatch?->bn_title}}</option>
    @empty

    @endforelse
</select>
<label for="batch_course">Select Course</label>
