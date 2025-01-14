<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Report</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f4f4;
      margin: 0; /* Remove default margin */
    }

    form {
      max-width: 600px;
      margin: 0 auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      padding-bottom: 50px;
      margin-bottom: 15px;
      margin-top: 0; /* Remove top margin */
    }

    label {
      display: block;
      margin-bottom: 8px;
    }

    input,
    select {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    button {
      background-color: #0078f0;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-bottom: 15px;
      float: right;
    }

    button:hover {
      background-color: #45a049;
    }

    .note {
      color: red;
      font-size: small;
      margin-top: -15px;
      margin-bottom: 15px;
    }

    .content {
      
    }

    /* language trans */
    #language-dropdown {
      position: relative;
      display: inline-block;
      border: 1px solid #333;
      border-radius: 15px;
      padding: 3px 3px ;
      float: right;
      /* margin-top: 4px; */
      margin-right: 10px;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
      z-index: 1;
    }

    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      display: block;
      text-decoration: none;
    }

    .dropdown-content a:hover {
      background-color: #f1f1f1;
    }

    #language-dropdown:hover .dropdown-content {
      display: block;
    }

    .top-bar {
      background-color: #333;
      color: white;
      padding: 5px;
      text-align: center;
      letter-spacing: 2px;
      font-weight: 500;
      margin-top: -1px;
    }

    img {
      height: 55px;
      width: auto;
      margin-top: -3px;
      vertical-align: middle;
    }

    @media (max-width: 600px) {
      .top-bar {
        letter-spacing: -1px;
        flex-direction: column;
        align-items: center;
      }

      #language-dropdown {
        margin-top: 4px;
      }

    }
  </style>
</head>
<body>


<h2 class="top-bar">
  <img src="updated.png" alt="logo">
  Official Incident Report Form
</h2>


<div class="content">
  <div id="language-dropdown" title="Select Language">
    <i class="fas fa-globe"></i>
    <span id="selected-language">Select Language <strong>⌵</strong></span>
      <div class="dropdown-content">
        <a href="#" onclick="setLanguage('en')">English</a>
        <a href="#" onclick="setLanguage('fil')">Filipino</a>
      </div>
  </div>
    
  <form action="onlineData.php" method="POST"  enctype="multipart/form-data" onsubmit="return validateFileSize()">
   
    <h2 id="form-title">Report an Incident</h2>
    <div class="note">
      <span id="note-text">Paalala: Ang pagpapasa ay ibabasura kung magbibigay ng maling o hindi tumpak na impormasyon.</span>
    </div>

    <label for="full_name" id="label-full-name">Complainant</label>
    <input type="text" id="full_name" name="full_name" required>

    <label for="contact_number" id="label-contact-number">Contact</label>
    <input type="text" id="contact_number" name="contact_number" maxlength="11" required>

    <label for="address" id="label-address">Address</label>
    <input type="text" id="address" name="address" required>

    <label for="complain" id="label-complain">Complain</label>
    <textarea id="complain" name="complain" rows="4" style="width: 100%; border: 1px solid #ccc; border-radius: 4px;"></textarea>

    <label for="respondent" id="label-respondent">Respondent</label>
    <input type="text" id="respondent" name="respondent">

    <label for="label-respondent-address" id="label-respondent-address">Respondent Address</label>
    <input type="text" id="label-respondent-address" name="respondentAddr">

    <label for="date" id="label-date">Date</label>
    <input type="text" id="date" name="date" placeholder="MM-DD-YYYY" required>

    <label for="time" id="time">Time</label>
    <input type="text" id="time" name="time" required>

    <button type="submit" id="submit-button">Submit</button>
  </form>

</div>

  <script>
    function setLanguage(language) {
      localStorage.setItem('language', language);
      location.reload();
    }

    function getLanguage() {
      return localStorage.getItem('language') || 'en';
    }

    // Function to set content dynamically based on language
    function setLanguageContent() {
      const language = getLanguage();

      // Example translations
      const translations = {
        'en': {
          'formTitle': 'Report an Incident',
          'noteText': 'Note: Submission will be forfeited if FALSE or INACCURATE information is provided.',
          'labelFullName': 'Complainant',
          'labelContactNumber': 'Contact',
          'labelAddress': 'Address',
          'labelComplain': 'Your Complain',
          'labelRespondent': 'Respondent',
          'labelAddrRespo': 'Respondent Address',
          'labelDate': 'Date',
          'labelTime': 'Time of Incident',
          'submitButton': 'Submit'

        },
        'fil': {
          'formTitle': 'Report an Incident',
          'noteText': 'Paalala: Ang pagbibigay o pagsusumite ng MALING impormasyon ay maaaring magresulta sa pagkakabasura ng aplikasyon o form.',
          'labelFullName': 'Pangalan ng nag-rereklamo',
          'labelContactNumber': 'Kontak',
          'labelAddress': 'Address',
          'labelComplain': 'Reklamo',
          'labelRespondent': 'Inirereklamo',
          'labelAddrRespo': 'Address ng  inirereklamo',
          'labelDate': 'Petsa',
          'labelTime': 'Oras ng insidente',
          'submitButton': 'Submit'
        },
        // Add translations for other languages as needed
      };

      // Set content based on the selected language
      document.getElementById('form-title').textContent = translations[language]['formTitle'];
      document.getElementById('note-text').textContent = translations[language]['noteText'];
      document.getElementById('label-full-name').textContent = translations[language]['labelFullName'];
      document.getElementById('label-contact-number').textContent = translations[language]['labelContactNumber'];
      document.getElementById('label-address').textContent = translations[language]['labelAddress'];
      document.getElementById('label-complain').textContent = translations[language]['labelComplain'];
      document.getElementById('label-respondent').textContent = translations[language]['labelRespondent'];
      document.getElementById('label-respondent-address').textContent = translations[language]['labelAddrRespo'];
      document.getElementById('label-date').textContent = translations[language]['labelDate'];
      document.getElementById('time').textContent = translations[language]['labelTime'];
      document.getElementById('submit-button').textContent = translations[language]['submitButton'];
    }

    // Call the function to set content based on language when the page loads
    setLanguageContent();

  </script>
</body>
</html>




