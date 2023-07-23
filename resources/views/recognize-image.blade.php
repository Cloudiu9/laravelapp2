<!DOCTYPE html>

<form action="/recognize-image" method="post">
    @csrf
    <label for="image_url">Image URL:</label>
    <input type="text" name="image_url" id="image_url" required>
    <button type="submit">Recognize Image</button>
</form>


