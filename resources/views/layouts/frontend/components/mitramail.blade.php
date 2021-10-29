<!DOCTYPE html>
<html>

<head>
     <title>Gabung Mitra Pakcer</title>
</head>

<body>
     <h3>Hallo Pakcer Indonesia, kami mau bergabung</h3>
     <p>Nama: {{ $details['Nama'] }}</p>
     <p>Nomor Hp: {{ $details['Nomor_hp'] }}</p>
     <p>Alamat Gudang: {{$details['Alamat_gudang']}}</p>
     <p>Luas Gudang: {{$details['Luas_gudang']}} m2</p>
     <?php
     $jumlahfasilitasgudang = count($details['Fasilitas_gudang']);
     $jumlahakseskendaraan=count($details['Akses_kendaraan']);
     ?>
     <p style="font-weight: bold;">Fasilitas Gudang:</p>

     @for ($i = 0; $i < $jumlahfasilitasgudang; $i++)

     <p>--{{$details['Fasilitas_gudang'][$i]}}</p>

     @endfor

     <p style="font-weight: bold;">Akses Kendaraan:</p>

     @for ($i = 0; $i < $jumlahakseskendaraan; $i++)

     <p>--{{$details['Akses_kendaraan'][$i]}}</p>

     @endfor

     <p>Bebas Banjir: {{$details['Bebas_banjir']}}</p>
     <p>Bebas Parkir: {{$details['Bebas_parkir']}}</p>
     <p>Kepemilikan Gudang: {{$details['Kepemilikan_gudang']}}</p>
</body>

</html>