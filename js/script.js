// Örnek randevu verileri (Veritabanından alınan verilerle dinamik hale getirilebilir)
let randevuListesi = [
  { randevu_saati: "2024-11-17 10:00:00", durum: "Bekliyor" },
  { randevu_saati: "2024-11-17 11:00:00", durum: "Bekliyor" },
  { randevu_saati: "2024-11-17 14:00:00", durum: "Bekliyor" },
];

// Kullanıcının seçtiği saat aralığını kontrol eden fonksiyon
function randevuKontrolu(secilenSaat) {
  // Seçilen saat ile mevcut randevu saatlerini karşılaştır
  let bulunmusRandevu = randevuListesi.some(
    (randevu) => randevu.randevu_saati === secilenSaat
  );

  if (bulunmusRandevu) {
    // Eğer saat zaten alınmışsa
    alert("Bu saat zaten alınmış! Lütfen başka bir saat seçin.");
    return false; // Randevu alınmasına izin verme
  } else {
    // Eğer saat boşsa
    alert("Randevunuz başarıyla oluşturuldu!");
    return true; // Randevu oluşturulmasına izin ver
  }
}

// Randevu saati seçim işlemi
document
  .getElementById("randevu-form")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Formun otomatik gönderilmesini engelle

    let secilenSaat = document.getElementById("randevu-saati").value;

    if (randevuKontrolu(secilenSaat)) {
      // Randevu başarılı bir şekilde oluşturulduğunda yapılacak işlemler
      console.log("Randevu başarıyla kaydedildi!");
    }
  });
