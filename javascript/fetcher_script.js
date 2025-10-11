async function setArtistOfMonth() {
      const monthKey = 'artistOfMonth_' + new Date().getFullYear() + '_' + (new Date().getMonth()+1);
      let artistData = localStorage.getItem(monthKey);
      if (artistData) {
        artistData = JSON.parse(artistData);
      } else {
        // Fetch random user (male or female)
        const userRes = await fetch('https://randomuser.me/api/?inc=name,picture,location,gender&noinfo');
        const userData = await userRes.json();
        const user = userData.results[0];
        artistData = {
          name: user.name.first + ' ' + user.name.last,
          img: user.picture.large,
          country: user.location.country,
          gender: user.gender,
          bio: `A talented ${user.gender === 'male' ? 'artist' : 'artist'} from ${user.location.country}. Passionate about creativity and expression.`
        };
        localStorage.setItem(monthKey, JSON.stringify(artistData));
      }

      // Set artist info
      document.querySelector('.artist-img').src = artistData.img;
      document.querySelector('.artist-img').alt = artistData.name;
      document.querySelector('.artist-name').textContent = artistData.name;
      document.querySelector('.artist-country').textContent = artistData.country;
      document.querySelector('.artist-bio').textContent = artistData.bio;
    }

    setArtistOfMonth();