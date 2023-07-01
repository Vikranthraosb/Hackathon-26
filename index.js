$(document).ready(function() {
    var faqItems = $('.faq-item');
    var currentIndex = 0;
    
    function showNextItem() {
      faqItems.removeClass('active');
      faqItems.eq(currentIndex).addClass('active');
      currentIndex = (currentIndex + 1) % faqItems.length;
    }
    
    setInterval(showNextItem, 5000); // Change the FAQ every 5 seconds (adjust as needed)
  });
  