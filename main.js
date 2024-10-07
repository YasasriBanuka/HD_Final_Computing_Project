// Initialize the index for the image display
let index = 0;

// Call the function to start displaying images
displayImages();

function displayImages() {
  // Variable to iterate through images
  let i;

  // Get all elements with the class name "image"
  const images = document.getElementsByClassName("image");

  // Loop through all images and hide them
  for (i = 0; i < images.length; i++) {
    images[i].style.display = "none";
  }

  // Increment the index to show the next image
  index++;

  // Reset the index if it exceeds the number of images
  if (index > images.length) {
    index = 1;
  }

  // Display the current image based on the index
  images[index - 1].style.display = "block";

  // Call the displayImages function again after 4 seconds (4000 milliseconds)
  setTimeout(displayImages, 4000);
}
