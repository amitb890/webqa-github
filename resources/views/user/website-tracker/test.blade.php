@extends('layouts.app')
@section('title', 'Website Tracker | Webqa')
@section("content")

@section("css")
<style>

#container {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
}

.draggable {
  width: 100px;
  height: 100px;
  background-color: lightblue;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  border: 1px solid #000;
  cursor: grab;
}

.draggable.dragging {
  opacity: 0.5;
}
</style>
@endsection
<div id="container">
  <div class="draggable" draggable="true">Div 1</div>
  <div class="draggable" draggable="true">Div 2</div>
  <div class="draggable" draggable="true">Div 3</div>
  <div class="draggable" draggable="true">Div 4</div>
</div>


@endsection
@section("js")
<script>
    const container = document.getElementById('container');
const draggables = document.querySelectorAll('.draggable');

draggables.forEach(draggable => {
  draggable.addEventListener('dragstart', () => {
    draggable.classList.add('dragging');
  });

  draggable.addEventListener('dragend', () => {
    draggable.classList.remove('dragging');
  });
});

container.addEventListener('dragover', e => {
  e.preventDefault();
  const draggingElement = document.querySelector('.dragging');
  const siblings = [...container.querySelectorAll('.draggable:not(.dragging)')];
  const nextSibling = siblings.find(sibling => {
    const siblingRect = sibling.getBoundingClientRect();
    return e.clientY < siblingRect.top + siblingRect.height / 2;
  });
  
  if (nextSibling) {
    container.insertBefore(draggingElement, nextSibling);
  } else {
    container.appendChild(draggingElement);
  }
});
</script>
@endsection