This was a program to see if I could automate replaceing the text of Japanese cards with English words. I made this to help with a another persons project of porting a Japanese card and board game over to an American audience. They supplied me with the translated card database (in Excell) and a bunch of scans of cards.

I started by making a photoshop png mask for each card type to cover upt the Japanese words. I then found the size of each area I was going to put text and created rules to put the text there. Often time these rules dealt with text wrap and seeing if the text could fit in a given box if not it would try the text again at the next smaaler font size. For some cards I set up rules to mirror the coloring of the Japanese cards. 

Due to Japanese text being data dense (2 characters or less can be a whole word), many of the translated words had to be shortend to fit in areas.

Although the text is hard coded into the tests the project was planed to have it read from the database of text and match them with the names from scanned cards.

Version control of this project was done by incrementing the file numbers.

The final working versions for each type of card are:

Zoid - test_overlay_zoid_database_test_6 - this show the program placing text for a long list of zoids onto the card for Gilvader.
Mobile Base - test_overlay_mobile_base_phase_6 - this show the mask on the card for Pingitrain, as well as the measurement and text readouts and the resizing needed from the scan.
Pilot - pilot_overlay_test_phase_three - this show the overaly for Moonbay, aptitude was not transfered as that was still being discussed on how to display.

I proved I could do the task but came to the conclusion that the game might not get done, so set this aside till it looked like the game would be made. 

![My Image](zoid_cards.jpg)

